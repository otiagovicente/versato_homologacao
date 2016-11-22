<template>
    <canvas v-el:canvas style="width: 100%; height: 200px"></canvas>
</template>

<script type="text/babel">
    import Chart from 'chart.js'

    export default {
        props:['type'],
        ready: function () {
            let canvas = this.$els.canvas
            let chart = new Chart(canvas, {
                type: this.type,
                data: {
                    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                    datasets: [{
                        label: '# of Votes',
                        data: [12, 19, 3, 5, 2, 3]
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            })
        }
    }
</script>