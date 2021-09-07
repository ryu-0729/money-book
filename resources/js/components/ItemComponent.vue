<template>
    <div class="col-md-10 text-md-center">
        今日は{{ disp }}ですよ。
    </div>
</template>

<script>
    export default {
        data() {
            return {
                disp: '0:0',
            }
        },
        mounted() {
            let d = new Date();
            this.disp = d.getFullYear().toString() + "/" + (d.getMonth()+1).toString() + "/" + d.getDate().toString();
        }
    }
</script>