//let Fetch = {

//  //
//  // Fetch.buttonAction
//  //

//  buttonAction: {
//    onReady: function() {
//      $(document).on('mousedown', '.my-button-file-remove', Fetch.buttonAction.remove);
//      $(document).on('click', '.my-button-file-remove', File.preventDefault);
//      $(document).on('mousedown', '.my-button-file-add', Fetch.buttonAction.add);
//      $(document).on('click', '.my-button-file-add', File.preventDefault);
//      $(document).on('mousedown', '.my-button-file-download', Fetch.buttonAction.download);
//      $(document).on('click', '.my-button-file-download', File.preventDefault);
//    },

//    remove: function(e) {
//      File.preventDefault(e);
//      $.when(Remove.file(File.id))
//        .done(function() {
//          $.ajax({
//                 type: 'GET',
//                 url: '/files/infos/0',
//                 dataType : 'json',
//                 data: {
//                   for: 'fetch'
//                 }
//          })
//          .done(function(next) {
//            File.id = next;
//            $.when(Fetch.getFileNav(next))
//              .then(File.trigger($(`#fileNavLinks a[data-id=${next}]`), 'mousedown'));
//            if (!next) {
//              history.pushState({ corg: true, id: 0 , oid: 1}, '', '/files');
//              File.assignDocumentLocation('/files');
//            }
//          })
//          .fail(function(msg) {
//            console.log(msg);
//          });
//        })
//        .fail(function(msg) {
//          // TODO
//          console.log(msg);
//        });
//    },

//    add: function(e) {
//      File.preventDefault(e);
//      history.pushState({ corg: true, id: File.id , oid: File.id}, '', '/files');
//      File.togglePage('Add', [ 'Fetch' ])
//    },

//    download: function(e) {
//      File.preventDefault(e);
//      Download.do(File.id);
//    }
//  },

//  //
//  // Fetch.getFileNav
//  //

//  getFileNav: function(id) {
//    $.ajax({
//           type: 'GET',
//           url: '/files',
//           dataType : 'json',
//           data: {
//             for: 'fetch'
//           }
//    })
//      .done(function(files) {
//        Fetch.setFileCount(files);
//        Fetch.appendFileNavLinks(files);
//        Fetch.setActiveFileNavLinks(id);
//      });
//  },

//  setFileCount: function(files) {
//    $('#fileCount').text(Object.keys(files).length);
//  },

//  appendFileNavLinks: function(files) {
//    $('.my-nav-link').remove();
//    $.each(files, function(k, v) {
//      $('#fileNavLinks')
//        .append(
//                `<a class="nav-link my-nav-link" href="/files/${k}" data-href="/files/${k}" data-id="${k}" data-name="${v}">${k}|${v}</a>`);
//    });
//  },

//  setActiveFileNavLinks: function(id) {
//    $(`#fileNavLinks a[data-id=${id}]`).addClass('active');
//  },


//  //
//  // Fetch.getFile
//  //

//  getFile: function(id) {
//    $.ajax({
//           type: 'GET',
//           url: '/files/' + id,
//           dataType : 'json',
//           data: {
//             for: 'fetch'
//           }
//    })
//      .done(function(file) {
//        Fetch.setFile(file);
//      });
//  },

//  setFile: function(file) {
//    // File.rec = JSON.parse(JSON.stringify(file));
//    File.rec = Object.assign({}, file);

//    $('#fetchFile input[id=mtime]').attr('placeholder', file.mtime);
//    $('#fetchFile input[id=size]').attr('placeholder', file.size);
//    $('#fetchFile input[id=mtype]').attr('placeholder', file.mtype);
//    $('#fetchFile textarea[id=description]').attr('placeholder', file.description);
//  },

//  //
//  // Fetch.getReferences
//  //

//  getReferences: function(id) {
//    $.ajax({
//           type: 'GET',
//           url: `/files/${id}/references`,
//           dataType : 'json',
//           data: {
//             for: 'fetch'
//           }
//    })
//      .done(function(references) {
//        Fetch.setReferencesCount(references);
//        Fetch.emptyTableReferences();
//        Fetch.appendTableReferences(references);
//      });
//  },

//  setReferencesCount: function(references) {
//   $('#referencesCount').text(Object.keys(references).length);
//  },

//  emptyTableReferences: function() {
//    $('#tableReferences tr.my-table-row-references').empty();
//  },

//  appendTableReferences: function(references) {
//    $.each(references, function(k, v) {
//      $('#tableReferences > tbody:last')
//        .append($(`<tr class="my-table-row-references" data-id="${k}" data-href="/activities/${k}">`)
//                .append(
//                        '<td>' + v.org + '</td>' +
//                        '<td>' + v.name + '</td>'
//                ));
//    });
//  },

//  //
//  // Fetch.changeActiveFile
//  //

//  changeActiveFile: {
//    onReady: function() {
//      $(document).on('click', 'a.my-nav-link', File.preventDefault);
//      $(document).on('mousedown', 'a.my-nav-link', Fetch.changeActiveFile.set);
//      $(document).on('click', 'tr.my-table-row-references', function() {
//        File.assignDocumentLocation($(this).data('href'));
//      });
//    },

//    set: function() {
//      var old = $('a.my-nav-link.active').data('id');
//      var href = $(this).data('href');
//      var _id = $(this).data('id');
//      var name = $(this).data('name');
//      File.id= _id;

//      $('a.my-nav-link.active').removeClass('active');
//      // $(this).addClass('active');
//      $(`#fileNavLinks a[data-id=${_id}]`).addClass('active');

//      $.when(Fetch.getFile(_id), Fetch.getReferences(_id))
//        .then(function() {
//          File.setDocumentTitle(name);
//          history.pushState({ corg: true, id: _id , oid: old}, '', href);
//        });
//    },
//  },

//  //
//  // Fetch.popState
//  //

//  popState: {
//    onReady: function() {
//      $(window).on('popstate', Fetch.popState.set);
//    },

//    set: function(e) {
//      if (e.originalEvent.state !== null) {
//        $('a.my-nav-link.active').removeClass('active');
//        active = $(`#fileNavLinks a[data-id=${e.originalEvent.state.id}]`);
//        active.addClass('active');
//        File.setDocumentTitle(active.data('name'));
//        Fetch.getFile(e.originalEvent.state.id);
//        Fetch.getReferences(e.originalEvent.state.id);
//      }
//    }
//  },

//  //
//  // Fetch.searchInput
//  //

//  searchInput: {
//    onReady: function() {
//      $(document).on('input', ':input[id=fileSearch]', Fetch.searchInput.toggle);
//    },

//    toggle: function() {
//      var val = $(this).val().toLowerCase();
//      $('#fileNavLinks a.my-nav-link')
//        .filter(function() {
//          $(this).toggle($(this).html().toLowerCase().indexOf(val) > -1)
//        });
//    }
//  },

//  //
//  // main
//  //

//  main: {
//    init: function() {
//      Fetch.main.build(File.id);
//      Fetch.main.setEvents();
//    },

//    build: function(id) {
//      Fetch.getFileNav(id);
//      Fetch.getFile(id);
//      Fetch.getReferences(id);
//    },

//    setEvents: function() {
//      Fetch.buttonAction.onReady();
//      Fetch.changeActiveFile.onReady();
//      Fetch.popState.onReady();
//      Fetch.searchInput.onReady();
//    },
//  }
//};
