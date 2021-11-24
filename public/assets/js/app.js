sendRequest = async (method, url, data, isJson = true) => {
    if (method === 'GET') {
        var request = await fetch(url, {
            headers: {
                isFetch: true
            }
        })
    }
    else {
        var request = await fetch(url, {
            method: method,
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        })
    }
    
    hideLoading()
    return await isJson ? request.json() : request.text()
}

showLoading = (message) => {
    Notiflix.Loading.Init({
        className: 'notiflix-loading',
        zindex: 4000,
        backgroundColor: 'rgba(0,0,0,0.8)',
        rtl: false,
        useGoogleFont: true,
        fontFamily: 'Quicksand',
        cssAnimation: true,
        cssAnimationDuration: 400,
        clickToClose: false,
        customSvgUrl: null,
        svgSize: '80px',
        svgColor: '#00b462',
        messageID: 'NotiflixLoadingMessage',
        messageFontSize: '15px',
        messageMaxLength: 34,
        messageColor: '#dcdcdc',
    });
    Notiflix.Loading.Hourglass(message);
}

hideLoading = () => {
    setTimeout(() => {
        Notiflix.Loading.Remove();
    }, 50);
}

showMessage = (type, message) => {
    if (type === 'success') {
        Notiflix.Notify.Success(message)
    }
    else if (type === 'failed') {
        Notiflix.Notify.Failure(message)
    }
}

tableJson = (id, callback) => {
    const table = document.getElementById(id).getElementsByTagName('tbody')[0]
    while(table.hasChildNodes())
    {
        table.removeChild(table.firstChild);
    }        
    callback(table)
}

pagination = (id, pagination, callback) => {
    document.getElementById(id).innerHTML = pagination
    const elPagination = document.querySelectorAll(`#${id} .pagination .page-item`)
    elPagination.forEach((el, i) => {
        el.addEventListener("click", (event) => {
            if (event.target.href !== undefined) callback(event.target.href)
            event.preventDefault()
        })
    })
}
