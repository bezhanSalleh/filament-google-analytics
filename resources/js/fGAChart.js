import Chart from "chart.js/auto";

export default function fGAChart({ labels, values }) {
    return {
        chart: null,

        init: function () {
            let chart = this.initChart();

            this.$wire.on("filterChartData", async ({ data }) => {
                chart.destroy();
                chart = this.initChart(data);
            });
        },

        initChart: function (data = null) {
            return (this.chart = new Chart(this.$refs.fgaCanvas, {
                type: "line",
                data: {
                    labels: labels,
                    datasets: [
                        {
                            data: data ?? values,
                            backgroundColor: getComputedStyle(
                                this.$refs.backgroundColorElement
                            ).color,
                            borderColor: getComputedStyle(
                                this.$refs.borderColorElement
                            ).color,
                            borderWidth: 2,
                            fill: "start",
                            tension: 0.5,
                        },
                    ],
                },
                options: {
                    elements: {
                        point: {
                            radius: 0,
                        },
                    },
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                    },
                    scales: {
                        x: {
                            display: false,
                        },
                        y: {
                            display: false,
                        },
                    },
                    tooltips: {
                        enabled: false,
                    },
                },
            }));
        },
    };
}
