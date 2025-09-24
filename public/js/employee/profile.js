document.addEventListener("DOMContentLoaded", () => {
    console.log('profile JS connected')
    let edit_details_button = document.querySelector('.edit_details_button')
    let close_edit_user_details = document.querySelector('#close_edit_user_details')
    let edit_user_details_modal = document.querySelector('.edit_user_details_modal')


    edit_details_button.addEventListener('click', ()=>{
        edit_user_details_modal.classList.remove('hidden');
    })
    close_edit_user_details.addEventListener('click', ()=>{
        edit_user_details_modal.classList.add('hidden');
    })

    let edit_skills_button = document.querySelector('#edit_skills_button')
    let cancel_skill_edit = document.querySelector('#cancel_skill_edit')
    let edit_skills_modal = document.querySelector('.edit_skills_modal')

    edit_skills_button.addEventListener('click', ()=>{
        edit_skills_modal.classList.remove('hidden')
    })
    cancel_skill_edit.addEventListener('click', ()=>{
    edit_skills_modal.classList.add('hidden') 
    })

    let profile_pic_clicked = document.querySelector('.profile_pic_clicked')
    let profile_pic_modal = document.querySelector('.profile_pic_modal')
    let close_profile_pic_modal = document.querySelector('#close_profile_pic_modal')

    profile_pic_clicked.addEventListener('click',()=>{
        profile_pic_modal.classList.remove('hidden')
    })

    close_profile_pic_modal.addEventListener('click',()=>{
        profile_pic_modal.classList.add('hidden')
    })

});