<!DOCTYPE html>
<html>
	<head>
		<title>WebChess</title>
		<meta charset="UTF8">
        <script>
            window.Polymer = window.Polymer || {};
            window.Polymer.dom = 'shadow';
        </script>
        <script src="lib/angular2-polyfills.js"></script>
        <script src="jspm_packages/system.js"></script>
        <script src="config.js"></script>
        <script src="lib/webcomponentsjs/webcomponents.min.js"></script>

        <script>
            System.import('js/boot')
                .then(null, console.error.bind(console));
        </script>
        <link rel="stylesheet" type="text/css" href="css/reset.css">
        <link rel="stylesheet" type="text/css" href="js/components/chess-board/assets/base.css">
        <link rel="stylesheet" type="text/css" href="js/components/chess-board/assets/desktop.css">
        <link rel="stylesheet" type="text/css" href="js/components/chess-board/assets/theme.css">

        <link rel="import" href="lib/paper-button/paper-button.html">
        <link rel="import" href="lib/paper-toolbar/paper-toolbar.html">
        <link rel="import" href="lib/paper-icon-button/paper-icon-button.html">
        <link rel="import" href="lib/iron-icons/iron-icons.html">
        <link rel="import" href="lib/paper-input/paper-input.html">
        <link rel="import" href="lib/paper-tabs/paper-tabs.html">
        <link rel="import" href="lib/paper-card/paper-card.html">
        <link rel="import" href="lib/paper-menu/paper-menu.html">
        <link rel="import" href="lib/paper-drawer-panel/paper-drawer-panel.html">
        <link rel="import" href="lib/iron-pages/iron-pages.html">
	</head>
	<body>
        <web-chess>Loading...</web-chess>
	</body>
</html>

