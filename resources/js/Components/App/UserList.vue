<script setup>
import DataTable from "datatables.net-vue3";

const props = defineProps({
    users: {
        type: Array
    },
})
</script>

<template>
    <DataTable class="w-full">
        <thead>
        <tr>
            <th scope="col"
                class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                Id
            </th>
            <th scope="col"
                class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                Name
            </th>
            <th scope="col"
                class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                Email
            </th>
        </tr>
        </thead>
        <tbody>
        <tr class="bg-gray-100 border-b" v-for="(item, i) in users" :key="i">
            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                {{ item.id }}
            </td>
            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                {{ item.name }}
            </td>
            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                {{ item.email }}
            </td>
        </tr>
        </tbody>
    </DataTable>
</template>

<style scoped>

</style>
