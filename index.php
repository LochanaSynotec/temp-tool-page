<?php
// Step 1: Create the New Folder "my-temp-php"
$phpFolder = "my-temp-php";
if (!file_exists($phpFolder)) {
    mkdir($phpFolder);
}

// Step 2: Fetch and Convert All HTML Files in the "my-temp" Folder to PHP
$htmlFolder = "my-temp";
$htmlFiles = glob($htmlFolder . "/*.html");

foreach ($htmlFiles as $htmlFile) {
    $htmlContent = file_get_contents($htmlFile);

    // Extract the Header and Footer Content
    $headerStart = strpos($htmlContent, '<header');
    $headerEnd = strpos($htmlContent, '</header>', $headerStart) + 9; // Include the closing tag

    $footerStart = strpos($htmlContent, '<footer');
    $footerEnd = strpos($htmlContent, '</footer>', $footerStart) + 9; // Include the closing tag

    $headerContent = substr($htmlContent, $headerStart, $headerEnd - $headerStart);
    $footerContent = substr($htmlContent, $footerStart, $footerEnd - $footerStart);

    // Save the Header and Footer as Separate PHP Files
    file_put_contents("{$phpFolder}/header.php", $headerContent);
    file_put_contents("{$phpFolder}/footer.php", $footerContent);

    // Remove Header and Footer from the HTML file and Replace with PHP Include
    $aboutContent = str_replace($headerContent, "<?php include 'header.php'; ?>", $htmlContent);
    $aboutContent = str_replace($footerContent, "<?php include 'footer.php'; ?>", $aboutContent);

    // Convert and Save the HTML file as PHP in the "my-temp-php" folder
    $phpFile = "{$phpFolder}/" . pathinfo($htmlFile, PATHINFO_FILENAME) . ".php";
    file_put_contents($phpFile, $aboutContent);
}
?>
