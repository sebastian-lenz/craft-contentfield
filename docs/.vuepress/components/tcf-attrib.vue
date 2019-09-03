<template>
  <tr>
    <td>{{ name }}</td>
    <td>
      <slot></slot>
    </td>
  </tr>
</template>

<script>
export default {
  name: "tcf-attrib",
  props: ["name"]
};
</script>
