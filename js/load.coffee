setBulletinHei = ->

    self     = this
    bulletin = document.getElementById( 'site-bulletin' )
    height   = window.innerHeight or document.documentElement.clientHeight or document.body.clientHeight

    bulletin.style.height = height 

document.addEventListener 'DOMContentLoaded', setBulletinHei 
