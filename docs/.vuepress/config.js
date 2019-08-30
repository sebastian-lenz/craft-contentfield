module.exports = {
  title: 'Content Field',
  description: 'The best way to work with templates in Craft CMS.',
  base: '/craft-contentfield/',
  themeConfig: {
    repo: 'sebastian-lenz/craft-contentfield',
    docsDir: 'docs',
    docsBranch: 'master',
    editLinks: true,
    nav: [
      { text: 'Home', link: '/' },
      { text: 'Getting started', link: '/tutorials/install/' },
      { text: 'Guide', link: '/guide/' },
      { text: 'Fields', link: '/fields/' },
    ],
    sidebar: {
      '/tutorials/': [
        'install/',
        {
          title: 'Basic setup',
          collapsable: false,
          children: [
            ['basic-setup/', 'Overview'],
            'basic-setup/01-entry-template',
            'basic-setup/02-content-template',
            'basic-setup/03-content-field',
            'basic-setup/04-section',
            'basic-setup/05-attach-field',
            'basic-setup/06-create-entry',
          ],
        },
        {
          title: 'Template hierarchies',
          collapsable: false,
          children: [
            ['hierarchy/', 'Overview'],
            'hierarchy/01-create-templates',
            'hierarchy/02-alter-content-template',
            'hierarchy/03-create-entry',
          ],
        },
      ],
      '/guide/': [
        '/guide/',
        'templates',
        'structures',
        'fields',
        'models',
        'settings',
      ],
      '/fields/': [
        'array',
        'checkbox',
        'color',
        'instance',
        'instances',
        'lightswitch',
        'link',
        'location',
        'number',
        'oembed',
        'redactor',
        'reference',
        'select',
        'swatch-color',
        'text',
        'textarea',
      ],
    },
  },
};