<script setup>
import {PencilSquareIcon, TrashIcon} from "@heroicons/vue/20/solid/index.js";
import {ref, watch} from "vue";
import PostUpdateModal from "@/Components/App/PostUpdateModal.vue";
import {router} from "@inertiajs/vue3";
import DataTable from "datatables.net-vue3";

const props = defineProps({
    categories: {
        type: Array
    },
    tags: {
        type: Array
    },
    posts: {
        type: Array
    },
    loadPosts: Boolean
})

const editPost = ref('');

const isOpen = ref(false);
function openPostModal(item) {
    editPost.value = item;
    isOpen.value = true;
}

watch(() => props.loadPosts, () => {
    console.log(props.loadPosts);
    console.log(props.posts);
})
function deletePost(item){
    if(window.confirm('Are you sure want to delete this post')){
        router.delete(route('post.destroy', item.id), {
            onSuccess: () => {
            }
        });
    }
}
</script>

<template>
    <DataTable class="w-full">
        <thead class="border-b">
        <tr>
            <th scope="col"
                class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                Image
            </th>
            <th scope="col"
                class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                Name
            </th>
            <th scope="col"
                class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                Slug
            </th>
            <th scope="col"
                class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                Created By
            </th>
            <th scope="col"
                class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                Content
            </th>
            <th scope="col"
                class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                Category
            </th>
            <th scope="col"
                class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                Tags
            </th>
            <th scope="col"
                class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                Action
            </th>
        </tr>
        </thead>
        <tbody>
        <tr class="bg-gray-100 border-b" v-for="(item, i) in posts" :key="i">
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                <img :src="item.image_url" class="w-20">
            </td>
            <td class="text-sm text-gray-900 font-light px-6 py-4">
                {{ item.name }}
            </td>
            <td class="text-sm text-gray-900 font-light px-6 py-4">
                {{ item.slug }}
            </td>
            <td class="text-sm text-gray-900 font-light px-6 py-4">
                {{ item.user.name }}
            </td>
            <td class="text-sm text-gray-900 font-light px-6 py-4">
                <p class="ck-content-output" v-html="item.content"></p>
            </td>
            <td class="text-sm text-gray-900 font-light px-6 py-4">
                {{ item.category.name }}
            </td>
            <td class="text-sm text-gray-900 font-light px-6 py-4">
                            <span v-for="(item, i) in item.tags" :key="1">
                                {{ item.name }}, </span>
            </td>
            <td class="text-sm text-gray-900 font-light px-6 py-4 ">
                <div class="flex items-center gap-1">
                    <PencilSquareIcon @click="openPostModal(item)" class="h-5 w-5 text-indigo-500 cursor-pointer"/>
                    <TrashIcon @click="deletePost(item)" class="h-5 w-5 text-red-500 cursor-pointer"/>
                </div>
            </td>
        </tr>
        </tbody>
    </DataTable>

    <PostUpdateModal :categories="categories"
                     :post="editPost"
                     :tags="tags" v-model="isOpen"/>
</template>

<style scoped>

</style>
