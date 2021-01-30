function submit(){
    iniciaLoading();
    document.querySelector('form').submit();
}


function iniciaLoading(){
    activity = Metro.activity.open({
        type: 'cycle',
        //style:'dark',
        overlayColor: '#AEA073',
        text: '<div class=\'mt-2 text-small\'>Espere por favor...</div>',
        overlayAlpha: .5
    });
}