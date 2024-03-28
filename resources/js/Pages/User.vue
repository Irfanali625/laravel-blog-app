<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import UserList from "@/Components/App/UserList.vue";

const props = defineProps({
    users: {
        type: Array
    },
})

</script>

<template>
    <Head title="Users"/>

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 pt-6 text-gray-900">
                        <div class="flex flex-col">
                            <div class="overflow-x-auto p-5 sm:-mx-6 lg:-mx-8">
                                <UserList :users="users"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<style>
@import 'datatables.net-dt';
</style>
