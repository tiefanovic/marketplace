var config = {
    map:{
        '*' : {
            'Tether': 'AWstreams_Marketplace/js/tether.min',
            'jquery.bootstrap': 'AWstreams_Marketplace/js/bootstrap.min',
            'datatables.net': 'AWstreams_Marketplace/js/datatables-net/media/js/jquery.dataTables.min',
            'datatables.net-buttons': 'AWstreams_Marketplace/js/datatables-net/extensions/buttons/js/dataTables.buttons.min',
            'datatables.net-bs4': 'AWstreams_Marketplace/js/datatables-net/media/js/dataTables.bootstrap4.min',
            'JSZip': 'AWstreams_Marketplace/js/jszip/jszip.min',
            'pdfMake': 'AWstreams_Marketplace/js/pdfmake/pdfmake.min'
        }

    },
    deps: [
        'AWstreams_Marketplace/js/datatables-net/extensions/buttons/js/buttons.bootstrap4.min',
        'AWstreams_Marketplace/js/pdfmake/vfs_fonts',
        'AWstreams_Marketplace/js/datatables-net/extensions/buttons/js/buttons.html5.min',
        'AWstreams_Marketplace/js/datatables-net/extensions/buttons/js/buttons.print.min',
        'AWstreams_Marketplace/js/datatables-net/extensions/buttons/js/buttons.colVis.min'

    ],
    "shim": {
        'Tether': ['jquery'],
        'jquery.bootstrap': ["jquery"],
        'datatables.net': ["jquery","jquery.bootstrap"],
        'datatables.net-buttons': ["jquery","jquery.bootstrap", "datatables.net", "datatables.net-bs4"]
    }
};