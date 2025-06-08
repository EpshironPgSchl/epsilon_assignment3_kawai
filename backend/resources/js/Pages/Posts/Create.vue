<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm} from '@inertiajs/vue3';

// Inertiaのフォームヘルパーを初期化
const form = useForm({
  title: '',
  content: ''
});

// フォームの送信処理
const submit = () => {
    form.post(route('posts.store'));
}
</script>

<template>
  <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">新規投稿作成</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit">
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
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>