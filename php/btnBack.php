<?php
function back($url, $align = null) {
    $style = "";
    switch ($align) {
        case "r":
            $style = "position: absolute; right: 100px;";
            break;
        case "l":
            $style = "position: absolute; top: 100px; left: 100px;";
            break;
            case "t-r":
                $style = "position: absolute; top: 100px; right: 100px;";
                break;
            case "t-l":
                $style = "position: absolute; top: 100px; left: 100px;";
                break;
        case "c":
            $style = "display: block; text-align: center; margin: 0 auto;";
            break;
        default:
            $style = "display: inline-block;";
            break;
    }
    echo '<a href="' . htmlspecialchars($url) . '.php" style="' . $style . '"><div class="btn-back" ><<< Retour</div class="btn-back" ></a>';
}
?>
