<template>
    <div class="progress" style="height: 1px;">
        <div
            :style="{ 'width': percentage + '%'}"
            class="progress-bar"
            role="progressbar"
            aria-valuemin="0"
            aria-valuemax="100">

        </div>
    </div>
</template>

<script>
    export default {
        props: ['percentage'],
    }
</script>
