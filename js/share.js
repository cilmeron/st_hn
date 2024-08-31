const copyCaption = (link) =>{
    navigator.clipboard.writeText(link);
    /* Notify the user that the text has been copied */
    document.querySelector(".copy__btn").innerText = "Link Copied!"

  }