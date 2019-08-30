<template>
  <table style="display:table;width:100%;">
    <colgroup>
      <col style="width:25%;" />
      <col style="width:75%;" />
    </colgroup>
    <thead>
      <tr>
        <th>Property</th>
        <th>Description</th>
      </tr>
    </thead>
    <tbody>
      <slot></slot>
    </tbody>
  </table>
</template>

<script>
export default {
  name: "tcf-attribs"
};
</script>
