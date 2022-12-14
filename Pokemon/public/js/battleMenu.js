$(document).ready(function () {
    let opponent = document.getElementById("opponent-select").value;
    document
        .getElementById("opponent-select")
        .addEventListener("change", function () {
            opponent = this.value;
        });
    document.getElementById("fullRand").addEventListener("click", function () {
        if (opponent == "") {
            alert("Please select an opponent");
            return;
        }
        window.location.href = "/battle/fullRandom/" + opponent;
    });
    document
        .getElementById("fullManual")
        .addEventListener("click", function () {
            if (opponent == "") {
                alert("Please select an opponent");
                return;
            }
            window.location.href = "/battle/fullManual/" + opponent;
        });
    document.getElementById("Mixed").addEventListener("click", function () {
        if (opponent == "") {
            alert("Please select an opponent");
            return;
        }
        window.location.href = "/battle/Mixed/" + opponent;
    });
});
