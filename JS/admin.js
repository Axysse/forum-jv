const users = document.getElementById("clk");
const rep = document.getElementById("clk2");
const posts = document.getElementById("clk3");

const navUsers = document.getElementById("navUsers");
const navRep = document.getElementById("navRep");
const navPost = document.getElementById("navPost")

displayUser = users.addEventListener("click", () => {
    if (navUsers.classList.contains("hidden")) {
        navUsers.classList.remove("hidden");
    } else {
        navUsers.classList.add("hidden");
    }
})

displayRep = rep.addEventListener("click", () => {
    if (navRep.classList.contains("hidden")) {
        navRep.classList.remove("hidden");
    } else {
        navRep.classList.add("hidden");
    }
})

displayPost = posts.addEventListener("click", () => {
    if (navPost.classList.contains("hidden")) {
        navPost.classList.remove("hidden");
    } else {
        navPost.classList.add("hidden");
    }
})






