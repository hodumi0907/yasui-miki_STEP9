// お気に入りボタンの色を変更する
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.like-btn').forEach(favBtn => {
    if (!favBtn) return;

        const icon = favBtn.querySelector('i');

        favBtn.addEventListener('click', function () {
            const productId = this.dataset.productId;
            const isLiked = icon.classList.contains('fa-solid');
            const url = `/products/${productId}/like`;

            fetch(url, {
                method: isLiked ? 'DELETE' : 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            console.log(data)
            //if (data.success) {
                icon.classList.toggle('fa-solid',data.liked);
                icon.classList.toggle('fa-regular',!data.liked);
                favBtn.classList.toggle('active');
            //}
        })
        .catch(err => console.error(err));
    });
    });
});