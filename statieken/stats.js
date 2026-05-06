fetch("/ticketstats")
.then(res => res.json())
.then(data => {

    const labels = data.map(item => item.datum);
    const values = data.map(item => item.aantal);

    new Chart(document.getElementById("ticketChart"), {
        type: "line",
        data: {
            labels: labels,
            datasets: [{
                label: "Tickets verkocht", 
                data: values, 
                fill: false, 
                tension: 0.2 
            }]
        }
    });

});