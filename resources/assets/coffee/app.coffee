(($) ->
  
  $("[data-link='components']").on "click", ->
    $(this).parents('.admin-page').removeClass('active')
    $('.admin-page.no-active').removeClass('no-active').addClass('active')
  
) jQuery