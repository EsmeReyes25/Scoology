const userIcon = document.querySelector('.user-drop .user-icon')
const menuOptions = document.querySelectorAll('.user-drop .menu-option')


const toggleClass = (item, className) => {
    if (item.className.indexOf(className) !== -1){
      item.className = item.className.replace(className,'')
    }
    else{
      item.className = item.className.replace(/\s+/g,' ') + 	' ' + className
    }
}

const toggleMenu = (e) => {
    const dropdown = e.currentTarget.parentNode;
    const menu = dropdown.querySelector('.drop-menu')
    //const icon = dropdown.querySelector('.fa-angle-right')
  
    toggleClass(menu,'hide')
    //toggleClass(icon,'rotate-90')
}


userIcon.addEventListener('click', e => {
    toggleMenu(e)
})

menuOptions.forEach((option) => {
    option.addEventListener('click', e => {
        //const icon = document.querySelector('.user-drop .title .fa')
        toggleClass(e.target.parentNode, 'hide')	
        //toggleClass(icon,'rotate-90',0)
    })
})