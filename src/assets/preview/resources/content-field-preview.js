(function() {
  var contentField = null;
  var controls = null;

  function renderCommand(command) {
    return [
      '<div class="tcfPreview--command" data-contentfield-api-command="', command.id ,'">',
        '<div class="tcfPreview--commandIcon">',
          '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">',
            renderCommandIcon(command.icon),
          '</svg>',
        '</div>',
        '<div class="tcfPreview--commandLabel">',
          command.label,
        '</div>',
      '</div>',
    ].join('');
  }

  function renderCommandIcon(icon) {
    switch (icon) {
      case 'material:add':
        return '<path fill="currentColor" d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>';
      case 'material:arrow_downward':
        return '<path fill="currentColor" d="M20 12l-1.41-1.41L13 16.17V4h-2v12.17l-5.58-5.59L4 12l8 8 8-8z"/>';
      case 'material:arrow_upward':
        return '<path fill="currentColor" d="M4 12l1.41 1.41L11 7.83V20h2V7.83l5.58 5.59L20 12l-8-8-8 8z"/>';
      case 'material:content_copy':
        return '<path fill="currentColor" d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H8V7h11v14z"/>';
      case 'material:content_cut':
        return '<path fill="currentColor" d="M9.64 7.64c.23-.5.36-1.05.36-1.64 0-2.21-1.79-4-4-4S2 3.79 2 6s1.79 4 4 4c.59 0 1.14-.13 1.64-.36L10 12l-2.36 2.36C7.14 14.13 6.59 14 6 14c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4c0-.59-.13-1.14-.36-1.64L12 14l7 7h3v-1L9.64 7.64zM6 8c-1.1 0-2-.89-2-2s.9-2 2-2 2 .89 2 2-.9 2-2 2zm0 12c-1.1 0-2-.89-2-2s.9-2 2-2 2 .89 2 2-.9 2-2 2zm6-7.5c-.28 0-.5-.22-.5-.5s.22-.5.5-.5.5.22.5.5-.22.5-.5.5zM19 3l-6 6 2 2 7-7V3z"/>';
      case 'material:content_paste':
        return '<path fill="currentColor" d="M19 2h-4.18C14.4.84 13.3 0 12 0c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm7 18H5V4h2v3h10V4h2v16z"/>';
      case 'material:delete':
        return '<path fill="currentColor" d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>';
      case 'material:edit':
        return '<path fill="currentColor" d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>';
      default:
        return '<path fill="currentColor" d="M10 16.5l6-4.5-6-4.5v9zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>';
    }
  }

  function renderCommands(commands) {
    var chunks = [];
    var group = undefined;
    var groupIndex = -1;

    for (var index = 0; index < commands.length; index++) {
      var command = commands[index];
      if (command.group !== group) {
        groupIndex += 1;
        if (groupIndex < 2) {
          chunks.push(
            chunks.length ? '</div>' : '',
            '<div class="tcfPreview--commandGroup">'
          );
        } else {
          chunks.push('<div class="tcfPreview--commandDivider"></div>');
        }
      }

      group = command.group;
      chunks.push(renderCommand(command));
    }

    chunks.push(chunks.length ? '</div>' : '');
    return chunks.join('');
  }

  function createControls(target, api) {
    var element = document.createElement('div');
    var frameId = -1;
    var isDisposed = false;
    element.className = 'tcfPreview';
    element.addEventListener('mouseleave', onMouseLeave);
    element.addEventListener('click', onClick);
    element.setAttribute('data-target', target.className);
    document.body.appendChild(element);

    api.subscribe(render);

    render();
    onFrame();

    function dispose() {
      if (isDisposed) return;
      isDisposed = true;

      api.unsubscribe();
      window.cancelAnimationFrame(frameId);
      document.body.removeChild(element);
    }

    function invoke(commandId) {
      var command = api.getCommands().find(function(command) {
        return command.id === commandId;
      });

      if (command) {
        command.invoke();
      }
    }

    function onClick(event) {
      var target = event.target;
      while (target) {
        var commandId = target.getAttribute('data-contentfield-api-command');
        if (commandId) {
          invoke(commandId);
          break;
        }

        target = target.parentElement;
      }
    }

    function onFrame() {
      var rect = target.getBoundingClientRect();
      var width = Math.max(rect.width, 320);
      var height = Math.max(rect.height, 64);

      element.style.left = (rect.left + (rect.width - width) * 0.5 + window.scrollX) + 'px';
      element.style.top = (rect.top + (rect.height - height) * 0.5 + window.scrollY) + 'px';
      element.style.width = width + 'px';
      element.style.height = height + 'px';
      element.classList.toggle('compact', height < 256 || width < 256)

      frameId = window.requestAnimationFrame(onFrame);
    }

    function onMouseLeave() {
      dispose();
    }

    function render() {
      element.innerHTML = renderCommands(api.getCommands());
    }

    return {
      dispose: dispose,
    };
  }

  function onMouseOver(event) {
    var target = event.target;
    while (target) {
      var uuid = target.getAttribute('data-contentfield-edit-uuid');
      if (!uuid) {
        target = target.parentElement;
        continue;
      }

      var api = contentField.getInstanceApi(uuid);
      if (!api) {
        return;
      }

      if (controls) controls.dispose();
      return controls = createControls(target, api);
    }
  }

  (function() {
    contentField = window.parent.contentField;
    if (typeof contentField !== 'object') {
      return;
    }

    document.addEventListener('mouseover', onMouseOver);
  })();
})();
