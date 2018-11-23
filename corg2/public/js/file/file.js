// let File = {
//   id: null,
//   employeeId: null,
//   curr_page: null,
//   rec: {},
//   tmp_name: null,

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

//   getLastFileId: function(f) {
//     $.ajax({
//            type: 'GET',
//            url: '/files/infos/0',
//            dataType : 'json',
//     })
//       .done(function(response) {
//         f(response);
//       })
//   },

//   togglePage: function(on, off) {
//     File.curr_page = on;

//     $('#mainLeftCol' + on).css({'display': 'block'});
//     $('#mainRightCol' + on).css({'display': 'block'});

//     for (let i = 0, len = off.length; i < len; i++) {
//       $('#mainLeftCol' + off[i]).css({'display': 'none'});
//       $('#mainRightCol' + off[i]).css({'display': 'none'});
//     }
//   },

//   scrollTop: function(sel) {
//       // $(window).scrollTop($(sel).offset().top);
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
//   File.id = File.getPathNameSegment(1) || 0;
//   // File.employeeId = File.getSessionEmployeeId();
//   File.curr_page = 'Fetch';
//   $.when(Fetch.main.init())
//     .then(function() {
//       Add.main.init();
//     });
// });
