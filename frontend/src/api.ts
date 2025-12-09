// const API = "http://localhost:8888/backend"; // docker
const API = "http://localhost:8888/pbe-block/backend/index.php"; // mamp

export const api = {
    getArticles: async (page: number) => {
        const res = await fetch(`${API}?action=getArticles&page=${page}`);
        return res.json();
    },

    getArticleById: async (id: number) => {
        const res = await fetch(`${API}?action=getArticle&id=${id}`);
        return res.json();
    },

    postArticle: async (title: string, text: string, url: string) => {
        const res = await fetch(`${API}?action=postArticle`, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ title, text, url }),
        });
        return res.json();
    },

    getComments: async (articleId: number) => {
        const res = await fetch(`${API}?action=getComments&id=${articleId}`);
        return res.json();
    },

    deleteComment: async (commentId: number) => {
        const res = await fetch(
            `${API}?action=deleteComment&commentId=${commentId}`,
            {
                method: "DELETE",
                headers: { "Content-Type": "application/json" },
            }
        );
        return res.ok;
    },

    postComment: async (
        articleId: number,
        name: string,
        email: string,
        url: string,
        commentText: string
    ) => {
        const res = await fetch(`${API}?action=postComment`, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ articleId, name, email, url, commentText }),
        });
        return res.json();
    },

    login: async (username: string, password: string) => {
        const res = await fetch(`${API}?action=login`, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ username, password }),
        });
        return res.json();
    },

    logout: async () => {
        const res = await fetch(`${API}?action=logout`, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
        });
        return res.json();
    },
};
