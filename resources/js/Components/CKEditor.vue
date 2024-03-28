<script setup>
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

const editor = ClassicEditor;
const editorConfig = {
    toolbar: [ 'heading', '|', 'bold', 'italic', '|', 'link', '|', 'bulletedList', 'numberedList',
        '|', 'outdent', 'indent', '|', 'blockQuote']
};

</script>

<template>
    <ckeditor :editor="editor" :config="editorConfig"></ckeditor>
</template>

<style scoped>

</style>
