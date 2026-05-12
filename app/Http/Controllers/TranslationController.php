<?php

namespace App\Http\Controllers;

use App\Models\TranslationCache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TranslationController extends Controller
{
    /**
     * Main endpoint: receives texts, checks cache, translates missing, returns all.
     */
    public function translatePage(Request $request)
    {
        $texts = $request->input('texts', []);
        $lang = $request->input('lang', 'es');
        $url = $request->input('url', '/');

        if (empty($texts)) {
            return response()->json([]);
        }

        $cached = $this->getCached($texts, $lang, $url);
        $missing = $this->findMissing($texts, $cached);

        if (!empty($missing)) {
            $translated = $this->callGroq($missing, $lang);
            $this->saveTranslations($missing, $translated, $lang, $url, $cached);
        }

        return response()->json($cached);
    }

    /**
     * Gets cached translations from DB.
     */
    private function getCached(array $texts, string $lang, string $url): array
    {
        return TranslationCache::where('lang', $lang)
            ->where('url', $url)
            ->whereIn('original', $texts)
            ->pluck('translated', 'original')
            ->toArray();
    }

    /**
     * Finds texts that are not in cache.
     */
    private function findMissing(array $texts, array $cached): array
    {
        $missing = [];
        foreach ($texts as $text) {
            if (!isset($cached[$text]) || $cached[$text] === $text) {
                $missing[] = $text;
            }
        }
        return $missing;
    }

    /**
     * Saves new translations to DB and adds them to the cached array.
     */
    private function saveTranslations(array $missing, array $translated, string $lang, string $url, array &$cached): void
    {
        foreach ($missing as $i => $original) {
            $tr = $translated[$i] ?? $original;
            if ($tr !== $original) {
                TranslationCache::updateOrCreate(
                    ['lang' => $lang, 'url' => $url, 'original' => $original],
                    ['translated' => $tr]
                );
                $cached[$original] = $tr;
            }
        }
    }

    /**
     * Calls Groq API to translate an array of texts.
     */
    private function callGroq(array $texts, string $lang): array
    {
        $apiKey = env('GROQ_API_KEY');
        if (empty($apiKey)) {
            return $texts;
        }

        $langNames = [
            'es' => 'Spanish',
            'en' => 'English',
            'fr' => 'French',
            'de' => 'German',
            'ca' => 'Catalan',
        ];

        $langName = $langNames[$lang] ?? $lang;
        $count = count($texts);

        $response = Http::timeout(30)->withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
        ])->post('https://api.groq.com/openai/v1/chat/completions', [
            'model' => 'llama-3.1-8b-instant',
            'temperature' => 0.1,
            'response_format' => ['type' => 'json_object'],
            'messages' => [
                [
                    'role' => 'system',
                    'content' => "You are a professional translator. Translate from Catalan to {$langName}. Reply ONLY with valid JSON.",
                ],
                [
                    'role' => 'user',
                    'content' => "Translate these {$count} Catalan texts to {$langName}. Return JSON: {\"translations\": [\"...\", \"...\"]} with exactly {$count} elements in same order.\n\nRules:\n- Translate ALL words including menu items, UI labels, and common words.\n- Only keep unchanged: school names, people names, and place names (e.g. 'Lycée Victor Hugo', 'Cendrassos', 'Itàlia 2026').\n- Dates and numbers: keep unchanged.\n- Everything else MUST be translated.\n\nTexts:\n" . json_encode($texts, JSON_UNESCAPED_UNICODE),
                ],
            ],
        ]);

        if (!$response->successful()) {
            return $texts;
        }

        $content = $response->json('choices.0.message.content', '{}');
        $content = preg_replace('/```json\s*/i', '', $content);
        $content = str_replace('```', '', $content);
        $parsed = json_decode(trim($content), true);

        return $parsed['translations'] ?? $texts;
    }
}
