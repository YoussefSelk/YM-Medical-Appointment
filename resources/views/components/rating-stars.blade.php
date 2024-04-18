<style>
    .rating {
        display: inline-block;
    }

    .rating input {
        display: none;
    }

    .rating label {
        float: right;
        cursor: pointer;
        color: #ccc;
        transition: color 0.3s;
    }

    .rating label:before {
        content: '\2605';
        font-size: 30px;
    }

    .rating input:checked~label,
    .rating label:hover,
    .rating label:hover~label {
        color: #0A76D8;
        transition: color 0.3s;
    }
</style>
<div class="rating">
    <input value="5" name="rating" id="star5" type="radio">
    <label for="star5"></label>
    <input value="4" name="rating" id="star4" type="radio">
    <label for="star4"></label>
    <input value="3" name="rating" id="star3" type="radio">
    <label for="star3"></label>
    <input value="2" name="rating" id="star2" type="radio">
    <label for="star2"></label>
    <input value="1" name="rating" id="star1" type="radio">
    <label for="star1"></label>
</div>
