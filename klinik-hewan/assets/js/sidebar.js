document.addEventListener("DOMContentLoaded", () => {

    const sidebar =
    document.querySelector(".sidebar");

    const toggle =
    document.querySelector(".sidebar-toggle");

    /* ====================
       ACTIVE MENU
    ==================== */

    const currentUrl =
    window.location.pathname;

    document
    .querySelectorAll(".sidebar ul li a")
    .forEach(link => {

        const href =
        link.getAttribute("href");

        if(currentUrl.includes(
            href.split("/").pop()
        )){
            link.classList.add("active");
        }

    });

    /* ====================
       COLLAPSE SIDEBAR
    ==================== */

    if(localStorage.getItem(
        "sidebar-state"
    ) === "collapsed")
    {
        sidebar.classList.add(
            "collapsed"
        );
    }

    if(toggle)
    {
        toggle.addEventListener(
            "click",
            () => {

                sidebar.classList.toggle(
                    "collapsed"
                );

                localStorage.setItem(
                    "sidebar-state",

                    sidebar.classList.contains(
                        "collapsed"
                    )

                    ? "collapsed"
                    : "expanded"
                );

            }
        );
    }

    /* ====================
       RIPPLE EFFECT
    ==================== */

    document
    .querySelectorAll(".sidebar a")
    .forEach(button => {

        button.addEventListener(
            "click",
            function(e){

                const ripple =
                document.createElement(
                    "span"
                );

                ripple.classList.add(
                    "ripple"
                );

                const rect =
                this.getBoundingClientRect();

                ripple.style.left =
                (e.clientX - rect.left)
                + "px";

                ripple.style.top =
                (e.clientY - rect.top)
                + "px";

                this.appendChild(
                    ripple
                );

                setTimeout(() => {

                    ripple.remove();

                },600);

            }
        );

    });

    /* ====================
       MENU ANIMATION
    ==================== */

    document
    .querySelectorAll(
        ".sidebar li"
    )
    .forEach((item,index)=>{

        item.style.opacity = "0";
        item.style.transform =
        "translateX(-20px)";

        setTimeout(()=>{

            item.style.transition =
            ".5s ease";

            item.style.opacity = "1";

            item.style.transform =
            "translateX(0)";

        },index * 100);

    });

    /* ====================
       HOVER GLOW
    ==================== */

    document
    .querySelectorAll(".sidebar a")
    .forEach(link => {

        link.addEventListener(
            "mouseenter",
            () => {

                link.style.boxShadow =
                "0 10px 25px rgba(79,70,229,.15)";

            }
        );

        link.addEventListener(
            "mouseleave",
            () => {

                link.style.boxShadow =
                "none";

            }
        );

    });

});