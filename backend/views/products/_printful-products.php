<h4>Available Colors</h4>
<table class="table table-bordered">
    <thead>
      <tr>
        <th>Color</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($products as $product): ?>
      <tr>
        <td><?php echo $product->color; ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>