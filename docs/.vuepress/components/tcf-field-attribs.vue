<template>
  <table>
    <thead>
      <tr>
        <th>Property</th>
        <th>Description</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="attribute in allAttributes">
        <td :class="{required: attribute.required}">
          <router-link v-if="attribute.link" :to="attribute.link">{{ attribute.name }}</router-link>
          <span v-else>{{ attribute.name }}</span>
        </td>
        <td>
          <span v-if="attribute.required">Required.</span>
          <span v-html="attribute.description"></span>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
const globalAttributes = require("../utils/globalFieldAttributes").default;

export default {
  name: "tcf-field-attribs",
  computed: {
    allAttributes() {
      return [...globalAttributes, ...this.getAttributes()].sort(
        (left, right) => left.name.localeCompare(right.name)
      );
    }
  },
  methods: {
    getAttributes() {
      const {
        frontmatter: { attributes = [] }
      } = this.$page;

      return attributes
        .map(attrib =>
          attrib.path
            ? this.getPageAttribute(attrib)
            : this.getLocalAttribute(attrib)
        )
        .filter(attrib => typeof attrib === "object" && "name" in attrib);
    },
    getLocalAttribute(attrib, page = this.$page) {
      return {
        ...attrib,
        link: `${page.path}#${attrib.name}`
      };
    },
    getPageAttribute({ path, name }) {
      const { pages } = this.$site;
      const target = pages.find(page => page.path === `${path}.html`);

      if (!target) {
        return null;
      }

      const {
        frontmatter: { attributes = [] }
      } = target;

      const attrib = attributes.find(attribute => attribute.name === name);
      return attrib ? this.getLocalAttribute(attrib, target) : null;
    }
  }
};
</script>
