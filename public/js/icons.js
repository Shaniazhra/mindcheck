(function () {
    var root = document.documentElement;
    function ready() { root.classList.add('icons-ready'); }
    if (!document.fonts || !document.fonts.load) { ready(); return; }
    document.fonts.load('24px "Material Symbols Outlined"').then(ready, ready);
    setTimeout(ready, 3000);
})();