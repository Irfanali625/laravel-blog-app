<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {PlusIcon} from "@heroicons/vue/20/solid";
import {Head} from "@inertiajs/vue3";
import {ref, watch} from "vue";
import PostCreateModal from "@/Components/App/PostCreateModal.vue";
import PostList from "@/Components/App/PostList.vue";

const props = defineProps({
    categories: {
        type: Array
    },
    tags: {
        type: Array
    },
    success: String,
    posts: Array
})
const isOpen = ref(false);

function openPostModal() {
    isOpen.value = true;
}

const loadPosts = ref(false);

const notification = ref(false);

watch(() => props.success, () => {
    notification.value = true;
    loadPosts.value = true;
    setTimeout(() => {
            notification.value = false;
    }, 5000)
})
</script>

<template>
    <Head title="Blogs"/>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div
                        v-show="notification && success"
                        class="px-2 py-3 font-medium text-sm bg-emerald-500 text-white"
                    >
                        {{ success }}
                    </div>
                    <div class="px-6 pt-6 text-gray-900">
                        <div class="flex justify-between items-center">
                            Blogs
                            <button
                                type="button"
                                class="flex items-center justify-center bg-indigo-500 p-1 rounded text-white"
                                @click="openPostModal"
                            >
                                <PlusIcon class="h-5 w-5"/>
                                Add Blog
                            </button>
                        </div>
                        <div class="mt-3 flex flex-col">
                            <hr>
                            <div class="overflow-x-auto p-5 sm:-mx-6 lg:-mx-8">
                                <PostList :posts="posts"
                                          :categories="categories"
                                          :tags="tags"
                                :loadPosts="loadPosts"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <PostCreateModal :categories="categories"
                             :tags="tags" v-model="isOpen"/>
        </div>
    </AuthenticatedLayout>
</template>
