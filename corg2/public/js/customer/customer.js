// let Customer = {
//   id: null,
//   employeeId: null,
//   curr_page: null,
//   rec: {},

//   getQueryVariable: function(qvar) {
//     let q = window.location.search.substring(1);
//     let qvars = q.split('&');
//     for (let i = 0; i < qvars.length; i++) {
//       let kv = qvars[i].split('=');
//       if (decodeURIComponent(kv[0]) == qvar) {
//         return decodeURIComponent(kv[1]);
//       }
//     }
//     return null;
//   },

//   getPathNameSegment: function(segment) {
//     let pathName = window.location.pathname.substring(1).split('/');
//     return pathName[segment];
//   },

//   getSessionEmployeeId: function() {
//     return $('#sessionEmployeeId:input:hidden').val();
//   },

//   preventDefault: function(e) {
//     e.preventDefault();
//   },

//   trigger: function(s, e) {
//     $(s).trigger(e);
//   },

//   assignDocumentLocation: function(loc) {
//     document.location.assign(loc);
//   },

//   setDocumentTitle: function(title) {
//     document.title = title;
//   },

//   getLastCustomerId: function(f) {
//     $.ajax({
//            type: 'GET',
//            url: '/customers/infos/0',
//            dataType : 'json',
//     })
//       .done(function(response) {
//         f(response);
//       })
//   },

//   togglePage: function(on, off) {
//     Customer.curr_page = on;

//     $('#mainLeftCol' + on).css({'display': 'block'});
//     $('#mainRightCol' + on).css({'display': 'block'});

//     for (let i = 0, len = off.length; i < len; i++) {
//       $('#mainLeftCol' + off[i]).css({'display': 'none'});
//       $('#mainRightCol' + off[i]).css({'display': 'none'});
//     }
//   },

//   scrollTop: function(sel) {
//       $(window).scrollTop();
//   },

//   textAsDownload: function(filename, mime, text) {
//     let element = document.createElement('a');
//     element.setAttribute('href', 'data:'
//                          + mime + 'charset=utf-8,' + encodeURIComponent(text));
//     element.setAttribute('download', filename);

//     element.style.display = 'none';
//     document.body.appendChild(element);

//     element.click();
//     document.body.removeChild(element);
//   }
// };

// $(function() {
//   Customer.id = Customer.getPathNameSegment(1) || 0;
//   Customer.employeeId = Customer.getSessionEmployeeId();
//   Customer.curr_page = 'Fetch';
//   $.when(Fetch.main.init())
//     .then(function() {
//       Add.main.init();
//       Edit.main.init();
//     });
// });
