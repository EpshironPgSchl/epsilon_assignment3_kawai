<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import CreatePostForm from './Create.vue'; // 追加

// コントローラから渡されたpropsを受け取る
const props = defineProps({
    posts: Object,
});
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">投稿一覧</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <!-- 投稿作成フォームをここに表示 -->
                        <CreatePostForm />

                        <ul>
                            <li v-for="post in props.posts.data" :key="post.id" class="mb-2">
                                <!-- 投稿タイトルとユーザー名をリンクとして表示 -->
                                <Link :href="route('posts.show', post.id)" class="text-blue-500 hover:text-blue-700">
                                    {{ post.title }} 
                                </Link>
                                <span class="text-gray-500 text-sm"> - {{ post.user.name }}</span>
                                <!-- 投稿の更新と削除リンク -->
                                <span v-if="$page.props.auth.user && $page.props.auth.user.id === post.user_id" class="mt-2" style="margin-left : 10px;">
                                    <Link :href="route('posts.edit', post.id)" class="text-indigo-600 hover:text-indigo-900">編集</Link>
                                    <Link 
                                        :href="route('posts.destroy', post.id)" 
                                        method="delete" 
                                        as="button" 
                                        class="text-red-600 hover:text-red-900 ml-2"
                                        onclick="return confirm('本当に削除しますか？')"
                                    >
                                        削除
                                    </Link>
                                </span>
                            </li>
                        </ul>
                        <!-- ページネーションリンク -->
                        <div class="mt-6 flex gap-2">
                            <Link
                                v-for="link in props.posts.links"
                                :key="link.label"
                                :href="link.url"
                                v-html="link.label"
                                :class="[
                                    'px-3 py-1 border rounded',
                                    link.active ? 'bg-blue-500 text-white' : 'bg-white text-blue-500',
                                    !link.url ? 'opacity-50 pointer-events-none' : ''
                                ]"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>