window.onload = () => {
    const lookupBtn = document.getElementById("lookup");
    const resultDiv = document.getElementById("result");

    lookupBtn.addEventListener("click", () => {
        const input = document.getElementById("country").value;

        fetch(`world.php?country=${encodeURIComponent(input)}`)
            .then(response => response.text())
            .then(data => {
                resultDiv.innerHTML = data;
            })
            .catch(err => {
                resultDiv.innerHTML = "Error: " + err;
            });
    });
};

