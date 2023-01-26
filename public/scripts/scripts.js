function getJwtToken() {
    return sessionStorage.getItem("jwt")
}

function setJwtToken(token) {
    sessionStorage.setItem("jwt", token)
}

function getRefreshToken() {
    return sessionStorage.getItem("refreshToken")
}

function setRefreshToken(token) {
    sessionStorage.setItem("refreshToken", token)
}