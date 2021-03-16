<template>
    <div class="section">
            <span class="section_header">
                <slot name="section_header">
                    Хедер
                </slot>
            </span>
            <div class="section_content">
                <slot name="section_content">
                    Боди
                </slot>
            </div>

    </div>
</template>

<script>
    export default {

    }
</script>

<style>
</style>

