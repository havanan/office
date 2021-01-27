<template>
    <div class="col-sm-12">
        <div class="card-box">
            <div class="row">
               <List :customerStatus="customerStatus"/>
            </div>
        </div>
    </div>
</template>

<script>
    import List from './ListComponent';
    export default {
        components: {
            List
        },
        props: [
            'customerStatus'
        ],
    }
</script>
