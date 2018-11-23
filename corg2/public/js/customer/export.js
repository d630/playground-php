// let Export = {
//   toVcard: function(id) {
//     $.ajax({
//            type: 'GET',
//            url: '/customers/' + id,
//            accepts: {
//              vcard: 'text/vcard'
//            },
//            converters : {
//              'text vcard': window.String
//            },
//            dataType : 'vcard'
//     })
//       .done(function(data) {
//         Customer.textAsDownload(`${Customer.rec.org}-${Customer.rec.family_name}_${Customer.rec.given_name}.vcard`,
//                                 'text/vcard',
//                                 data);
//       });
//   }
// };
