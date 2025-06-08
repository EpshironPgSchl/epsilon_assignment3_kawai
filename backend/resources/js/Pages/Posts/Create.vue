<script setup>
import { useForm } from '@inertiajs/vue3';
const form = useForm({
  title: '',
  content: ''
});

// フォームの送信処理
const submit = () => {
    form.post(route('posts.store'), {
        onSuccess: () => {
            form.reset(); // フォームをリセット
        },
    })
}
</script>

<template>
  <form @submit.prevent="submit" class="mb-8">
    <div class="mb-4">
      <label for="title" class="block text-gray-700 text-sm font-bold mb-2">タイトル</label>
      <input type="text" v-model="form.title" id="title" class="shadow appearance-none border rounded w-full py-2 px-3">
      <div v-if="form.errors.title" class="text-red-500 text-xs mt-1">{{ form.errors.title }}</div>
    </div>
    <div class="mb-6">
      <label for="content" class="block text-gray-700 text-sm font-bold mb-2">本文</label>
      <textarea v-model="form.content" id="content" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3"></textarea>
      <div v-if="form.errors.content" class="text-red-500 text-xs mt-1">{{ form.errors.content }}</div>
    </div>
    <div class="flex items-center justify-end">
      <button type="submit" :disabled="form.processing" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        投稿する
      </button>
    </div>
  </form>
</template>