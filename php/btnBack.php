<?php
function back($url, $align = null) {
    $style = "";
    switch ($align) {
        case "r":
            $style = "position: absolute; right: 10px;";
            break;
        case "l":
            $style = "position: absolute; top: 10px; left: 10px;";
            break;
            case "t-r":
                $style = "position: absolute; top: 10px; right: 10px;";
                break;
            case "t-l":
                $style = "position: absolute; top: 10px; left: 10px;";
                break;
        case "center":
            $style = "display: block; text-align: center; margin: 0 auto;";
            break;
        default:
            $style = "display: inline-block;";
            break;
    }
    echo '<a href="' . htmlspecialchars($url) . '.php" class="btn-back" style="' . $style . '"><<< Retour</a>';
}
?>