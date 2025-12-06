document.addEventListener("DOMContentLoaded", () => {
    const input = document.getElementById("country");
    const r = document.getElementById("result");

    document.getElementById("lookup-country").addEventListener("click", () => {
        const coun = encodeURIComponent(input.value);
        fetch(`world.php?country=${coun}`)
            .then(response => response.text())
            .then(data => r.innerHTML = data)
            .catch(err => r.innerHTML = "Error fetching country data");   
    });

    document.getElementById("lookup-cities").addEventListener("click", () => {
        const coun = encodeURIComponent(input.value);
        fetch(`world.php?country=${coun}&lookup=cities`)
            .then(response => response.text())
            .then(data => r.innerHTML = data)
            .catch(err => r.innerHTML = "Error fetching city data");
    });
});

 

