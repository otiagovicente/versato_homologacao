<template>
    <div class="content-fluid content-pagination" style="padding:20px;"  v-if="show">
        <div class="row">
            <ul class="pagination">
                <li><a @click="select(page - 1)" v-if="showFirst">Previous</a></li>
                <li v-for="p of list" :class="{'active': p==page}">
                    <a @click="select(p)">{{p}}</a>
                </li>
                <li><a @click="select(page + 1)" v-if="showLast">Next</a></li>
            </ul>
        </div>
    </div>
</template>

<style>
    .content-pagination { text-align: center; }
</style>

<script>

    export default {
        data() {
            return {
                show: false,
                showFirst: false,
                showLast: false,
                list: []
            }
        },
        props: [ 'pages', 'page' ],
        ready() {
            this.processPageList()
        },
        watch: {
            pages() { this.processPageList() },
            page() { this.processPageList() }
        },
        methods:{
            processPageList() {
                let range = 5
                let min = (this.page - range < 1) ? 1 : this.page - range
                let max = (this.page + range > this.pages) ? this.pages : this.page + range

                // marca flags
                this.show = this.pages > 0
                this.showFirst = min > 1
                this.showLast = max < this.pages

                // prepara lista
                this.list = []
                for(let i = min; i <= max; i++) {
                    this.list.push(i)
                }
            },
            select(page) {
                this.$emit('select', page)
            }
        }
    }
</script>
