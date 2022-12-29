package SimpleTree;

public class SimpleTreeNode<Integer, E> {

    E value;
    int index;
    SimpleTreeNode<Integer, E> left;
    SimpleTreeNode<Integer, E> right;



    SimpleTreeNode(int key, E it)
    {
        this.index = key;
        this.value = it;
        right = null;
        left = null;
    }

    public void traverseInOrder(SimpleTreeNode<Integer, E> node) {
        if (node != null) {
            traverseInOrder(node.left);
            System.out.print(" " + node.index);
            traverseInOrder(node.right);
        }
    }

    public void traverseInOrderValues(SimpleTreeNode<Integer, E> node) {
        if (node != null) {
            traverseInOrderValues(node.left);
            System.out.print(" " + node.value.toString());
            traverseInOrderValues(node.right);
        }
    }


}
