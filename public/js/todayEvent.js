function todayEvent() {
    let eventItem = document.querySelectorAll(".today-event__item")
    eventItem.forEach(function(elemitem) {
        let title = elemitem.querySelector('.event-item__title').textContent;
        let startTime = elemitem.querySelector('.event-item__start_time').textContent;
        let endTime = elemitem.querySelector('.event-item__end_time').textContent;
        let description = elemitem.querySelector('.event-item__text').textContent;
        let id = elemitem.querySelector('.event-id').textContent;
        let assigned = elemitem.querySelector('.event-assigned').textContent;
        
        elemitem.addEventListener('click', function(e) {

            fetch('/organaizer/public/api/checkEvent' + '/' + id, {
                    method: 'PUT',
                    body: id,
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json; charset=UTF-8',
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then((response) => {
                    return response.json();
                })
                .then((data) => {
                    console.log(data);
                });
                
         var DateStart = new Date(startTime);
         let newStartDate = DateStart.setHours(DateStart.getHours()+3);
         var clickDate = new Date(newStartDate).toISOString();

         var DateEnd = new Date(endTime);
         let newEndDate = DateEnd.setHours(DateEnd.getHours()+3);
         var clickDateEnd = new Date(newEndDate).toISOString();

         $('body').css("overflow", "visible");
         $('body').css("background", "black");
            $('#today__evet').css("display", "none")
            $('#start').css("display", "none");
            $('#end').css("display", "none");
            $('#repeatedEvent').css("display", "none");
            $('#title').val(title);
            $('#start2').val(clickDate.substring(0,clickDate.length-8));
            $('#end2').val(clickDateEnd.substring(0,clickDateEnd.length-8));
            $('#description').val(description);
            $('#eventId').val(id);
            $('#assigned').val(assigned);
            $('#deliteEvent').attr('href', '/organaizer/public/deleteEvent' + '/' + id);
            $('.title-text').html('Обновить событие');
            $('#update').html('Обновить');
            $('#dialog').dialog({
                width: 500,
                height: 800,
                modal: true,
            })
        })
    })
}