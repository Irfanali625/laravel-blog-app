<script setup>
import {computed, ref} from "vue";
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from "@headlessui/vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {XMarkIcon} from "@heroicons/vue/16/solid";
import TextInput from "@/Components/TextInput.vue";
import {useForm} from "@inertiajs/vue3";
import CKEditor from "@/Components/CKEditor.vue";

const props = defineProps({
    modelValue: Boolean,
    categories: {
        type: Array
    },
    tags: {
        type: Array
    },
})

const form = useForm({
    name: '',
    category: '',
    tags: [],
    content: '',
    image: null
})

const emit = defineEmits(['update.modelValue'])

const show = computed({
    get: () => props.modelValue,
    set: (value) => emit('update.modelValue', value)
})

function closeModal() {
    emit('update:modelValue', false);
    errors.value = {};
}
function onImageSelect(event) {
    form.image = event.target.files[0];
    if (form.image) {
        const reader = new FileReader();
        reader.onload = () => {
        }
        reader.readAsDataURL(form.image);
    }
}
const errors = ref({});
function submit(){
    if(form.name.trim() === ''){
        errors.value.name = 'Name field is required';
    }
    if(form.category === ''){
        errors.value.category = 'Category field is required';
    }
    if(form.tags === ''){
        errors.value.tags = 'Tag field are required';
    }

    form.post(route('post.create'), {
        preserveScroll: true,
        onSuccess: () => {
            emit('update:modelValue', false);
            form.reset();
            errors.value = {};
        }
    });
}

</script>
<template>
    <TransitionRoot appear :show="show" as="template">
        <Dialog as="div" @close="closeModal" class="relative z-10">
            <TransitionChild
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-black/25"/>
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto">
                <div
                    class="flex min-h-full items-center justify-center p-4 text-center"
                >
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100"
                        leave="duration-200 ease-in"
                    >
                        <DialogPanel
                            class="w-full max-w-md transform rounded bg-white p-3 text-left
                                    align-middle shadow-xl transition-all h-[520px] overflow-auto"
                        >
                            <DialogTitle
                                as="h3"
                                class="py-1 px-2 flex items-center rounded justify-between font-medium bg-gray-100
                                    leading-6 text-gray-900"
                            >
                                Add Post
                                <button class="h-8 w-8 rounded-full hover:bg-black/5 flex items-center
                                    justify-center">
                                    <XMarkIcon @click="closeModal" class="w-5 h-5"/>
                                </button>
                            </DialogTitle>
                            <div class="my-4">
                                <TextInput class="w-full" v-model="form.name"
                                           :class="{'border-red-400': errors.name && !form.name}" placeholder="Name"/>
                                <span v-if="errors.name && !form.name" class="text-red-400 py-2">{{errors.name}}</span>
                            </div>
                            <div class="my-4">
                                <select
                                    v-model="form.category"
                                    :class="{'border-red-400': errors.category && !form.category}"
                                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="" disabled>Select</option>
                                    <option v-for="(item, i) in categories" :key="i"
                                            :value="item.id"
                                    >{{ item.name }}
                                    </option>
                                </select>
                                <span v-if="errors.category && !form.category" class="text-red-400 py-2">{{errors.category}}</span>
                            </div>
                            <div class="my-4">
                                <select
                                    v-model="form.tags"
                                    :class="{'border-red-400': errors.tags && !form.tags}"
                                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    multiple>
                                    <option disabled>Select</option>
                                    <option v-for="(item, i) in tags" :key="i"
                                            :value="item.id"
                                    >{{ item.name }}
                                    </option>
                                </select>
                                <span v-if="errors.tags && !form.tags" class="text-red-400 py-2">{{errors.tags}}</span>
                            </div>
                            <div class="my-4">
                                <CKEditor v-model="form.content" />
                            </div>
                            <div class="my-4">
                                <input type="file" @change="onImageSelect">
                            </div>
                            <div class="mt-4 flex items-center">
                                <PrimaryButton @click="submit">
                                    Submit
                                </PrimaryButton>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
