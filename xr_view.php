<?php
session_start();
include("functions.php");
check_session_id();

//DB接続
$pdo = connect_to_db();

//SQLで参照
$sql = 'SELECT * FROM item_table WHERE user_id=? AND is_deleted=0 AND public=1 ORDER BY created_at DESC';

$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$status = $stmt->execute(); // SQLを実行 $statusに実行結果(取得したデータではない！)


// 失敗時にエラーを出力し，成功時は登録画面に戻る
if ($status == false) {
    $error = $stmt->errorInfo();  // データ登録失敗時にエラーを表示
    exit('sqlError:' . $error[2]);
} else {
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);  //fetchAllで全部とれる
    $output = '';
    //繰り返し文（foreach以外）でもOK
    foreach ($result as $key => $record) {
        // var_dump($result);
        // exit;

        $countx = 0;
        $countz = ($key * -15) + 8;
        $countl = 0;


        // if ($key > 7) {
        //     $countz = ($key * 1) + 10;
        //     $countl = -90;
        //     $countx = 0;
        // } else {
        //     $countz = -9;
        //     $countl = 0;
        //     $countx = ($key * -5) + 8;
        // }

        $output .=
            "<a-image src='" . $record['item_img'] . "' 
            width='4' height='3' position='$countx 3 $countz' 
            rotation='0 $countl 0 ' >
            </a-image>";
    }

    // for ($record = 0; $record < 20; $record++) {
    // }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>こども美術館</title>
    <script src="https://aframe.io/releases/1.2.0/aframe.min.js"></script>
    <link rel="stylesheet" href="view.css">
    <link rel="stylesheet" href="style.css">


    <!-- <script src="https://cdn.rawgit.com/jeromeetienne/AR.js/1.5.0/aframe/build/aframe-ar.js"></script> -->
    <!-- <script src="https://raw.githack.com/AR-js-org/AR.js/master/aframe/build/aframe-ar-nft.js"></script> -->

    <!-- 空のグラデーションのためのコンポーネント呼び出し -->
    <!-- <script src="https://unpkg.com/aframe-environment-component@1.0.0/dist/aframe-environment-component.min.js"></script> -->
</head>

<body style="margin: 0; overflow: hidden">
    <a-scene vr-mode-ui="enabled: false">
        <!-- <a-entity id="ca-container" class="ca-container" position="0 -5 0" rotation="100 0 0"></a-entity> -->
        <a-sky color="#e6e6e6"></a-sky>
        <a-light type="ambient"></a-light>
        <?= $output ?>

        <a-entity camera position="0 0 15" wasd-controls="enabled: true">
        </a-entity>
        <a-box position="1 4 -3" rotation="0 45 0" material="color: #ffb0b0" animation="property: rotation; from: 0 0 0; to: 360 360 0; loop: true; dur: 5000; easing: linear" animation__2="property: scale; from: 0.5 0.5 0.5; to: 0.1 0.1 0.1; dur: 1000; loop: true; dir: alternate"></a-box>
        <a-box position="2 6 -6" rotation="0 45 0" material="color: #ffb0b0" animation="property: rotation; from: 0 0 0; to: 360 360 0; loop: true; dur: 5000; easing: linear" animation__2="property: scale; from: 0.5 0.5 0.5; to: 0.1 0.1 0.1; dur: 1000; loop: true; dir: alternate"></a-box>
        <a-box position="3 10 -8" rotation="0 45 0" material="color: #ffb0b0" animation="property: rotation; from: 0 0 0; to: 360 360 0; loop: true; dur: 5000; easing: linear" animation__2="property: scale; from: 0.5 0.5 0.5; to: 0.1 0.1 0.1; dur: 1000; loop: true; dir: alternate"></a-box>
        <a-box position="-2 2 -4" rotation="0 45 0" material="color: #ffb0b0" animation="property: rotation; from: 0 0 0; to: 360 360 0; loop: true; dur: 5000; easing: linear" animation__2="property: scale; from: 0.5 0.5 0.5; to: 0.1 0.1 0.1; dur: 1000; loop: true; dir: alternate"></a-box>
        <a-box position="-3 0 -15" rotation="0 45 0" material="color: #ffb0b0" animation="property: rotation; from: 0 0 0; to: 360 360 0; loop: true; dur: 5000; easing: linear" animation__2="property: scale; from: 0.5 0.5 0.5; to: 0.1 0.1 0.1; dur: 1000; loop: true; dir: alternate"></a-box>
        <a-box position="-1 7 -30" rotation="0 45 0" material="color: #ffb0b0" animation="property: rotation; from: 0 0 0; to: 360 360 0; loop: true; dur: 5000; easing: linear" animation__2="property: scale; from: 0.5 0.5 0.5; to: 0.1 0.1 0.1; dur: 1000; loop: true; dir: alternate"></a-box>
        <a-box position="-1 0 -50" rotation="0 45 0" material="color: #ffb0b0" animation="property: rotation; from: 0 0 0; to: 360 360 0; loop: true; dur: 5000; easing: linear" animation__2="property: scale; from: 0.5 0.5 0.5; to: 0.1 0.1 0.1; dur: 1000; loop: true; dir: alternate"></a-box>
        <a-box position="2 6 -100" rotation="0 45 0" material="color: #ffb0b0" animation="property: rotation; from: 0 0 0; to: 360 360 0; loop: true; dur: 5000; easing: linear" animation__2="property: scale; from: 0.5 0.5 0.5; to: 0.1 0.1 0.1; dur: 1000; loop: true; dir: alternate"></a-box>
        <a-box position="-3 5 -150" rotation="0 45 0" material="color: #ffb0b0" animation="property: rotation; from: 0 0 0; to: 360 360 0; loop: true; dur: 5000; easing: linear" animation__2="property: scale; from: 0.5 0.5 0.5; to: 0.1 0.1 0.1; dur: 1000; loop: true; dir: alternate"></a-box>
        <a-box position="1 10 -200" rotation="0 45 0" material="color: #ffb0b0" animation="property: rotation; from: 0 0 0; to: 360 360 0; loop: true; dur: 5000; easing: linear" animation__2="property: scale; from: 0.5 0.5 0.5; to: 0.1 0.1 0.1; dur: 1000; loop: true; dir: alternate"></a-box>
        <a-box position="-5 2 -250" rotation="0 45 0" material="color: #ffb0b0" animation="property: rotation; from: 0 0 0; to: 360 360 0; loop: true; dur: 5000; easing: linear" animation__2="property: scale; from: 0.5 0.5 0.5; to: 0.1 0.1 0.1; dur: 1000; loop: true; dir: alternate"></a-box>
        <a-box position="-2 -1 -360" rotation="0 45 0" material="color: #ffb0b0" animation="property: rotation; from: 0 0 0; to: 360 360 0; loop: true; dur: 5000; easing: linear" animation__2="property: scale; from: 0.5 0.5 0.5; to: 0.1 0.1 0.1; dur: 1000; loop: true; dir: alternate"></a-box>
        <a-box position="2 -2 -350" rotation="0 45 0" material="color: #ffb0b0" animation="property: rotation; from: 0 0 0; to: 360 360 0; loop: true; dur: 5000; easing: linear" animation__2="property: scale; from: 0.5 0.5 0.5; to: 0.1 0.1 0.1; dur: 1000; loop: true; dir: alternate"></a-box>
        <a-box position="4 4 -420" rotation="0 45 0" material="color: #ffb0b0" animation="property: rotation; from: 0 0 0; to: 360 360 0; loop: true; dur: 5000; easing: linear" animation__2="property: scale; from: 0.5 0.5 0.5; to: 0.1 0.1 0.1; dur: 1000; loop: true; dir: alternate"></a-box>
        <a-box position="-3 6 -450" rotation="0 45 0" material="color: #ffb0b0" animation="property: rotation; from: 0 0 0; to: 360 360 0; loop: true; dur: 5000; easing: linear" animation__2="property: scale; from: 0.5 0.5 0.5; to: 0.1 0.1 0.1; dur: 1000; loop: true; dir: alternate"></a-box>
        <a-box position="4 4 -505" rotation="0 45 0" material="color: #ffb0b0" animation="property: rotation; from: 0 0 0; to: 360 360 0; loop: true; dur: 5000; easing: linear" animation__2="property: scale; from: 0.5 0.5 0.5; to: 0.1 0.1 0.1; dur: 1000; loop: true; dir: alternate"></a-box>
        <a-box position="1 3 -510" rotation="0 45 0" material="color: #ffb0b0" animation="property: rotation; from: 0 0 0; to: 360 360 0; loop: true; dur: 5000; easing: linear" animation__2="property: scale; from: 0.5 0.5 0.5; to: 0.1 0.1 0.1; dur: 1000; loop: true; dir: alternate"></a-box>
        <a-box position="2 10 -520" rotation="0 45 0" material="color: #ffb0b0" animation="property: rotation; from: 0 0 0; to: 360 360 0; loop: true; dur: 5000; easing: linear" animation__2="property: scale; from: 0.5 0.5 0.5; to: 0.1 0.1 0.1; dur: 1000; loop: true; dir: alternate"></a-box>
        <a-box position="3 2 -550" rotation="0 45 0" material="color: #ffb0b0" animation="property: rotation; from: 0 0 0; to: 360 360 0; loop: true; dur: 5000; easing: linear" animation__2="property: scale; from: 0.5 0.5 0.5; to: 0.1 0.1 0.1; dur: 1000; loop: true; dir: alternate"></a-box>
        <a-box position="3 -2 -580" rotation="0 45 0" material="color: #ffb0b0" animation="property: rotation; from: 0 0 0; to: 360 360 0; loop: true; dur: 5000; easing: linear" animation__2="property: scale; from: 0.5 0.5 0.5; to: 0.1 0.1 0.1; dur: 1000; loop: true; dir: alternate"></a-box>
        <a-box position="-1 10 -600" rotation="0 45 0" material="color: #ffb0b0" animation="property: rotation; from: 0 0 0; to: 360 360 0; loop: true; dur: 5000; easing: linear" animation__2="property: scale; from: 0.5 0.5 0.5; to: 0.1 0.1 0.1; dur: 1000; loop: true; dir: alternate"></a-box>
        <a-box position="-5 7 -610" rotation="0 45 0" material="color: #ffb0b0" animation="property: rotation; from: 0 0 0; to: 360 360 0; loop: true; dur: 5000; easing: linear" animation__2="property: scale; from: 0.5 0.5 0.5; to: 0.1 0.1 0.1; dur: 1000; loop: true; dir: alternate"></a-box>
        <!-- <a-entity camera animation="property: rotation; from: 0 0 0; to: 0 360 0; loop: true; dur: 50000; easing: linear">
        </a-entity> -->

    </a-scene>
    <footer>
        <div class="nav_bottom">
            <a href="view.php" class="btn"><i class="fas fa-home fa-lg"></i></a>
            <a href="file_upform.php" class="btn "><i class="fas fa-plus-square fa-lg"></i></a>
            <a href="child.php" class="btn"><i class="fas fa-user-alt fa-lg"></i></a>
        </div>
    </footer>


    <script src="https://kit.fontawesome.com/b28496ef11.js" crossorigin="anonymous"></script>
    <!-- <script>
        const item = <?= json_encode($result) ?>;
        console.log(item);
    </script> -->


    <!-- セルオートマン -->
    <!-- <script>
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
        };
    </script> -->
</body>

</html>