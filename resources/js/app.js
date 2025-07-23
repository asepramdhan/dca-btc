import "./bootstrap";
import Chart from "chart.js/auto";
import ChartDataLabels from "chartjs-plugin-datalabels";

Chart.register(ChartDataLabels);

// Konfigurasi global datalabels
Chart.defaults.plugins.datalabels = {
    display: function (context) {
        return context.dataset.data[context.dataIndex] !== null;
    },
    formatter: function (value, context) {
        if (value === null) return "";

        const axis = context.dataset.yAxisID;

        if (axis === "y1") {
            // Sumbu persentase
            return value.toFixed(1) + "%";
        }

        // Sumbu biasa (misal: nominal), pakai format angka ribuan
        return value.toLocaleString("id-ID", {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
        });
    },
    anchor: function (context) {
        return context.dataset.data[context.dataIndex] < 0 ? "start" : "end";
    },
    align: function (context) {
        return context.dataset.data[context.dataIndex] < 0 ? "start" : "end";
    },
    offset: 0, // biar label tidak overlap dengan bar
    clip: true, // memastikan label tidak keluar area grid
    color: function (context) {
        return context.dataset.yAxisID === "y1" ? "#ff9f40" : "#4b5563"; // abu untuk nominal
    },
    font: {
        weight: "bold",
        size: 12,
    },
    position: function (context) {
        return context.dataset.data[context.dataIndex] < 0
            ? "insideBottom"
            : "insideTop";
    },
};

window.Chart = Chart; // ← ini penting untuk Alpine
