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

const formatDateTime = (value: string | null): string => {
	if (!value) return '--';

	const date = new Date(value);
	if (Number.isNaN(date.getTime())) return value;

	return date.toLocaleString('ca-ES', {
		day: '2-digit',
		month: '2-digit',
		year: 'numeric',
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
				<h1 class="mb-3 lg:text-7xl font-bold text-hp-primary-dark sm:text-3xl">
					{{ post.title }}
				</h1>

				<div class="mb-5 flex flex-row justify-between text-sm text-hp-text-dim sm:grid-cols-2">
					<p>
						<strong>Inici:</strong>
						{{ formatDateTime(post.start_date) }}
					</p>
					<p>
						<strong>Fi:</strong>
						{{ formatDateTime(post.end_date) }}
					</p>
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