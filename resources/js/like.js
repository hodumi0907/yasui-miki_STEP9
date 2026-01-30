// お気に入りボタンの色を変更する
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.like-btn').forEach(btn => {
        const icon = btn.querySelector('i');
        let isProcessing = false;

        btn.addEventListener('click', function () {
            if (isProcessing) return;
            isProcessing = true;

            const productId = btn.dataset.productId;
            const url = `/products/${productId}/like`;

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]')
                        .content,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                btn.classList.toggle('liked', data.liked);
                icon.classList.toggle('fa-solid', data.liked);
                icon.classList.toggle('fa-regular', !data.liked);
            })
            .catch(err =>{
                console.error(err);
                alert('お気に入り登録に失敗しました。');
            })
            .finally(() => {
                isProcessing = false;
            });
        });
    });
});