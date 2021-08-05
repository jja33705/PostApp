<template>
    <v-container>
        <v-row justify="center" dense style="height: 100px;" align="center">
                <h2>게시글 작성</h2>
        </v-row>
        <v-row>
            <v-text-field label="title">

            </v-text-field>
        </v-row>
        <v-row>
            <v-textarea label="content"></v-textarea>
        </v-row>
        <v-row justify="end">
            <v-col cols="2">
                <v-btn>저장</v-btn>
            </v-col>
        </v-row>
    </v-container>
</template>




<script>
export default {

}
</script>