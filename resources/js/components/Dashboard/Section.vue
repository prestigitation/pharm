<template>
    <div class="section ">
        <div class="section_header">
            <span>
                <slot name="section_header">
                    Хедер
                </slot>
            </span>
        </div>

        <div class="section_content">
            <slot name="section_content">
                Боди
            </slot>
        </div>
    </div>
</template>

<script>
import UsersData from './UsersData';
import UsersUpdate from './UsersUpdate';
    export default {

    }
</script>

<style lang="scss">
</style>
