import "./bootstrap";
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap";
import jQuery from "jquery";
import DataTable from "datatables.net-bs5";
import "datatables.net-responsive-bs5";
import Chart from "chart.js/auto";
import Swal from "sweetalert2";

window.$ = jQuery;
window.Swal = Swal;

// Initialize DataTables
$(document).ready(function () {
    // Orders table
    if ($("#ordersTable").length) {
        $("#ordersTable").DataTable({
            responsive: true,
            pageLength: 10,
            order: [[0, "desc"]],
        });
    }

    // Orders Chart (render only if canvas exists AND ordersData is provided by the page)
    if ($("#ordersChart").length && typeof ordersData !== "undefined") {
        const ctx = document.getElementById("ordersChart").getContext("2d");
        new Chart(ctx, {
            type: "line",
            data: {
                labels: ordersData.labels,
                datasets: [
                    {
                        label: "Orders",
                        data: ordersData.values,
                        borderColor: "rgb(59, 130, 246)",
                        tension: 0.1,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: "top",
                    },
                    title: {
                        display: true,
                        text: "Orders Trend",
                    },
                },
            },
        });
    }

    // Delete confirmation
    $(".delete-order").click(function (e) {
        e.preventDefault();
        const form = $(this).closest("form");

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();
