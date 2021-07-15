
let width;
let height;
let cellSize;
let columns;
let rows;
let boardState;
let nextState;
let elArray;

let onColor = "black";
let offColor = "white";

let caContainer = null;
let aScene = null;

const initDefinition = () => {
    width = 20;
    height = 20;
    cellSize = 1;
    columns = Math.floor(width / cellSize);
    rows = Math.floor(height / cellSize);

    currentState = new Array(columns);
    for (let i = 0; i < columns; i++) {
        currentState[i] = new Array(rows);
    }
    nextState = new Array(columns);
    for (i = 0; i < columns; i++) {
        nextState[i] = new Array(rows);
    }
    elArray = new Array(columns);
    for (i = 0; i < columns; i++) {
        elArray[i] = new Array(rows);
    }
    console.log(elArray);
};

const initContainerPosition = () => {
    caContainer = document.getElementById("ca-container");
    caContainer.setAttribute(
        "position",
        `${-width / 2 + cellSize / 2} 8 ${-height * 1.2}`
    );
};

const initAddGrid = () => {
    for (let x = 0; x < columns; x++) {
        for (let y = 0; y < rows; y++) {
            const newEl = document.createElement("a-box");
            newEl.setAttribute("color", offColor);
            newEl.setAttribute("scale", `${cellSize} ${cellSize} ${cellSize}`);
            newEl.setAttribute("position", `${y} 0 ${x}`);
            newEl.setAttribute("opacity", "0.5");
            caContainer.appendChild(newEl);
            elArray[x][y] = newEl;
        }
    }
};

const initRandomSet = () => {
    for (let i = 0; i < columns; i++) {
        for (let j = 0; j < rows; j++) {
            if (i == 0 || j == 0 || i == columns - 1 || j == rows - 1) {
                currentState[i][j] = 0;
            } else {
                currentState[i][j] = Math.round(Math.random(2));
            }
        }
    }
};

const drawCa = () => {
    generate();
    for (let i = 0; i < columns; i++) {
        for (let j = 0; j < rows; j++) {
            if (currentState[i][j] == 1) elArray[i][j].setAttribute("color", onColor);
            else elArray[i][j].setAttribute("color", offColor);
        }
    }
};

const generate = () => {
    for (let x = 1; x < columns - 1; x++) {
        for (let y = 1; y < rows - 1; y++) {
            let neighbors = 0;
            for (let i = -1; i <= 1; i++) {
                for (let j = -1; j <= 1; j++) {
                    neighbors += currentState[x + i][y + j];
                }
            }
            neighbors -= currentState[x][y];
            // loneliness
            if (currentState[x][y] == 1 && neighbors < 2) nextState[x][y] = 0;
            // overpopulation
            else if (currentState[x][y] == 1 && neighbors > 3)
                nextState[x][y] = 0;
            // reqroduction
            else if (currentState[x][y] == 0 && neighbors == 3)
                nextState[x][y] = 1;
            //stasis
            else nextState[x][y] = currentState[x][y];
        }
    }

    let temp = currentState;
    currentState = nextState;
    nextState = temp;
}

window.onload = () => {
    initDefinition();
    initContainerPosition();
    initAddGrid();
    initRandomSet();
    setInterval(() => {
        drawCa();
    }, 100);
}