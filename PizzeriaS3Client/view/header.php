<link href="style.css" rel="stylesheet" type="text/css" />

<script>
    //EASTER EGG
    function e() {
        function n(e) {
            if (e.nodeType === Node.TEXT_NODE) {
                let n = ["#E70000", "#FF8C00", "#FFEF00", "#00811F", "#0044FF", "#760089"];
                let o = e.nodeValue.replace(/\p{L}+/gu, () => {
                    return atob("Tk/J").split("").map((e) => `<span style="color: ${n[Math.floor(Math.random() * n.length)]};">${e}</span>`).join("");
                });
                let a = document.createElement("span");
                a.innerHTML = o;
                e.parentNode.replaceChild(a, e);
            } else Array.from(e.childNodes).forEach(n);
        }
      
        n(document.body);
    }

    let t = "";

    document.addEventListener("keydown", function (n) {
        let o = n.key.toUpperCase();
        t += o;
        if (t === "NOE") {
            e();
            t = "";
        }
    });
</script>
