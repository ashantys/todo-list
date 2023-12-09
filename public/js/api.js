function createTodo() {
    const container = document.getElementById("container");
    const input = document.getElementById("title");
    const title = input.value;

    axios.post("/todo/create", { 
        title: title })
        .then(response => {
            const data = response.data;

            if (data.message === "Ok") {
                const todo = data.todo;

                const date = new Date(todo.created_at);
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, "0");
                const day = String(date.getDate()).padStart(2, "0");
                const hours = String(date.getHours()).padStart(2, "0");
                const minutes = String(date.getMinutes()).padStart(2, "0");
                const seconds = String(date.getSeconds()).padStart(2, "0");

                const formattedDate = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;


                const card = `
                <div class="card mt-3 animate__animated animate__zoomIn" id="card${todo.id}">
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="${todo.id}">
                            <label class="form-check-label" for="${todo.id}">
                                ${todo.title}
                            </label>
                        </div>
                        <p class="me-5">Fecha de creación: ${formattedDate}</p>
                        <button class="btn btn-danger mt-3" onclick="deleteTodo(${todo.id})">Eliminar Tarea</button>
                    <div>
                </div>
                `;

                container.insertAdjacentHTML("beforeend", card);

                input.value = "";

                setTimeout(function () {
                    var cards = document.getElementsByClassName("card");
                    for (var i = 0; i < cards.length; i++) {
                        cards[i].classList.remove("animate__zoomIn");
                    }
                }, 1000);
            } else {
                console.log(data)
                alert(data.message);
            }
        })
        .catch(error => {
            console.log(error.response.data);
        });
}

var checkboxes = document.querySelectorAll("input[type='checkbox']");

checkboxes.forEach(function (checkbox) {
    checkbox.addEventListener("change", function () {
        const check = this.checked ? 1 : 0;

        axios.post(`/todo/update/${this.id}`, { check })
            .catch(error => {
                alert(error.response.data.message);
            });
    });
});

function deleteTodo(id) {
    var deleteCard = document.getElementById(`card${id}`);
    var indexCard = Array.from(deleteCard.parentNode.children).indexOf(deleteCard);

    axios.delete(`/todo/delete/${id}`)
        .then(response => {
            const data = response.data;

            if (data.message === "Ok") {
                deleteCard.classList = "card mt-3 animate__animated animate__zoomOut";

                setTimeout(function () {
                    var tarjetasRestantes = document.getElementsByClassName("card");
                    for (var i = indexCard + 1; i < tarjetasRestantes.length; i++) {
                        tarjetasRestantes[i].classList = "card mt-3 animate__animated animate__fadeInUp";
                    }
                    deleteCard.remove();
                }, 800);

                setTimeout(function () {
                    var cards = document.getElementsByClassName("card");
                    for (var i = 0; i < cards.length; i++) {
                        cards[i].classList.remove("animate__fadeInUp");
                    }
                }, 1750);
            }
        })
        .catch(error => {
            console.log(error.response.data);
            alert(error.response.data.message);
        });
}
