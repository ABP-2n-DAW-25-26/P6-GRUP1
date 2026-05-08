<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

interface PostImage {
	id: number;
	image_path: string;
}

interface Post {
	id: number;
	title: string;
	description: string | null;
	start_date: string | null;
	end_date: string | null;
	file: string | null;
	exchange_id: number | string;
	images?: PostImage[];
}

const props = defineProps<{
	post: Post;
}>();

const formatDate = (value: string | null): string => {
	if (!value) return '--';

	const date = new Date(value);
	if (Number.isNaN(date.getTime())) return value;

	return date.toLocaleString('ca-ES', {
		day: '2-digit',
		month: '2-digit',
		year: 'numeric',
	});
};

const formatTime = (value: string | null): string => {
	if (!value) return '--';

	const date = new Date(value);
	if (Number.isNaN(date.getTime())) return value;

	return date.toLocaleString('ca-ES', {
		hour: '2-digit',
		minute: '2-digit',
	});
};

const getDescription = (description: string | null): string => {
	const text = description?.trim();
	if (!text) return '—';

	const withoutHtmlTags = text
		.replace(/<style[\s\S]*?<\/style>/gi, ' ')
		.replace(/<script[\s\S]*?<\/script>/gi, ' ')
		.replace(/<[^>]+>/g, ' ')
		.replace(/\s+/g, ' ')
		.trim();

	return withoutHtmlTags || '—';
};

const imageUrl = (imagePath: string | null | undefined): string => {
	if (!imagePath) return '';
	return `/storage/${imagePath}`;
};
</script>

<template>
	<Head :title="post.title" />

	<div class=" p-4 sm:p-6">
		<div class="mx-auto w-full max-w-4xl">

			<div class="rounded-2xl sm:p-6">
				<p class="mb-2 font-hp text-lg font-semibold uppercase tracking-wide text-hp-primary">
					Anunci
				</p>
				<h1 class="mb-3 lg:text-7xl font-bold text-hp-primary-dark text-4xl">
					{{ post.title }}
				</h1>

				<div class="mb-5 bg-hp-bg/30 rounded-xl p-4 flex flex-row justify-between text-sm text-hp-text-dim gap-20 sm:grid-cols-2">
					<div class="border-l-3 rounded border-hp-primary pl-3"> 
						<p>Inici</p>
						<p><strong>{{ formatDate(post.start_date) }}</strong></p>
						<p>{{ formatTime(post.start_date) }}</p>
					</div>
					<div class="border-r-3 rounded border-hp-primary text-right pr-3"> 
						<p>Fi</p>
						<p><strong>{{ formatDate(post.end_date) }}</strong></p>
						<p>{{ formatTime(post.end_date) }}</p>
					</div>
				</div>

				<div class="max-w-none my-2 text-hp-text">
					{{ getDescription(post.description) }}
				</div>

				<div v-if="post.images && post.images.length > 0" class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
					<img v-for="image in post.images" :key="image.id" :src="imageUrl(image.image_path)" alt="Imatge del post"
						class="h-52 w-full rounded-xl border border-gray-200 object-cover"/>
				</div>

				<div v-else-if="post.file" class="mt-6">
					<img :src="imageUrl(post.file)" alt="Imatge del post"
						class="max-h-112 w-full rounded-xl border border-gray-200 object-contain"/>
				</div>
			</div>
		</div>
	</div>
</template>