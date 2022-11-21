// document.getElementsByTagName("body")[0].style.background = "red";
function handleFiles(files) {
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        if (!file.type.startsWith("image/")) {
            continue;
        }
        const img = document.createElement("img");
        img.classList.add("obj");
        img.file = file;
        img.src = URL.createObjectURL(file);
        document.getElementById("preview").appendChild(img);
        document.getElementById("dropbox").style.display = "none";
        const reader = new FileReader();
        reader.onload = (function (aImg) {
            return function (e) {
                aImg.src = e.target.result;
            };
        })(img);
        reader.readAsDataURL(file);
    }
}
// document.getElementById("upload").addEventListener("change", function (event) {
//     handleFiles(event.target.files);
// });
//create a dropzone for files in the dropbox div
const dropbox = document.getElementById("dropbox");
dropbox.addEventListener("dragenter", dragenter, false);
dropbox.addEventListener("dragover", dragover, false);
dropbox.addEventListener("drop", drop, false);

function dragenter(e) {
    e.stopPropagation();
    e.preventDefault();
}

function dragover(e) {
    e.stopPropagation();
    e.preventDefault();
}

function drop(e) {
    e.stopPropagation();
    e.preventDefault();
    const dt = e.dataTransfer;
    const files = dt.files;

    handleFiles(files);
}
